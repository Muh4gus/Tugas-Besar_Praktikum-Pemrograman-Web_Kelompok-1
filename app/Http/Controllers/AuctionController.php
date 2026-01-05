<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\AuctionItem;
use App\Models\AuctionLog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class AuctionController extends Controller
{
    /**
     * Display listing of auction items.
     */
    public function index(Request $request)
    {
        $query = AuctionItem::with(['category', 'user', 'winner']);
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        $items = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = Category::all();
        return view('admin.items.index', compact('items', 'categories'));
    }
    /**
     * Show form for creating new auction item.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.items.create', compact('categories'));
    }
    /**
     * Store a newly created auction item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'starting_price' => ['required', 'numeric', 'min:0'],
            'minimum_bid_increment' => ['required', 'numeric', 'min:1000'],
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date', 'after:start_time'],
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('auctions', 'public');
        }
        $item = AuctionItem::create([
            'user_id' => auth()->id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image' => $imagePath,
            'starting_price' => $validated['starting_price'],
            'current_price' => $validated['starting_price'],
            'minimum_bid_increment' => $validated['minimum_bid_increment'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'status' => 'active',
        ]);
        AuctionLog::log(
            $item->id,
            auth()->id(),
            'auction_created',
            'Auction item "' . $item->title . '" created'
        );
        return redirect()->route('admin.items.index')->with('success', 'Item lelang berhasil dibuat!');
    }
    /**
     * Display the specified auction item.
     */
    public function show($id)
    {
        $item = AuctionItem::with(['category', 'user', 'winner', 'bids.user', 'logs'])
            ->findOrFail($id);
        return view('admin.items.show', compact('item'));
    }
    /**
     * Show form for editing auction item.
     */
    public function edit($id)
    {
        $item = AuctionItem::findOrFail($id);
        $categories = Category::where('is_active', true)->get();
        return view('admin.items.edit', compact('item', 'categories'));
    }
    /**
     * Update the specified auction item.
     */
    public function update(Request $request, $id)
    {
        $item = AuctionItem::findOrFail($id);
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', 'in:pending,active,ended,cancelled'],
            'end_time' => ['required', 'date'],
        ]);
        if ($request->hasFile('image')) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $validated['image'] = $request->file('image')->store('auctions', 'public');
        }
        $oldStatus = $item->status;
        $item->update($validated);
        if ($oldStatus !== $validated['status']) {
            AuctionLog::log(
                $item->id,
                auth()->id(),
                'status_changed',
                'Status changed from ' . $oldStatus . ' to ' . $validated['status'],
                $oldStatus,
                $validated['status']
            );
        }
        return redirect()->route('admin.items.index')->with('success', 'Item lelang berhasil diperbarui!');
    }
    /**
     * Remove the specified auction item.
     */
    public function destroy($id)
    {
        $item = AuctionItem::findOrFail($id);
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }
        AuctionLog::log(
            null,
            auth()->id(),
            'auction_deleted',
            'Auction item "' . $item->title . '" deleted'
        );
        $item->delete();
        return redirect()->route('admin.items.index')->with('success', 'Item lelang berhasil dihapus!');
    }
    /**
     * Validate and set winner.
     */
    public function validateWinner($id)
    {
        $item = AuctionItem::findOrFail($id);
        if ($item->total_bids === 0) {
            return back()->with('error', 'Tidak ada bid untuk lelang ini.');
        }
        $highestBid = $item->highestBid();
        if ($highestBid) {
            $item->update([
                'winner_id' => $highestBid->user_id,
                'status' => 'ended',
            ]);
            $highestBid->markAsWinning();
            AuctionLog::log(
                $item->id,
                auth()->id(),
                'winner_declared',
                'Winner declared: ' . $highestBid->user->name . ' with bid Rp ' . number_format($highestBid->amount, 0, ',', '.')
            );
            return back()->with('success', 'Pemenang berhasil ditetapkan!');
        }
        return back()->with('error', 'Tidak dapat menetapkan pemenang.');
    }
}
