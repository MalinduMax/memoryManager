<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MemoryBlock;

class MemoryController extends Controller
{
    // Display memory blocks and processes
    public function index()
    {
        $blocks = MemoryBlock::all();
        return view('memory.index', compact('blocks'));
    }

    // Handle memory allocation using Best Fit
    public function allocate(Request $request)
    {
        $processSize = $request->input('process_size');

        // Find the smallest block that can fit the process
        $bestBlock = MemoryBlock::where('allocated', false)
            ->where('size', '>=', $processSize)
            ->orderBy('size')
            ->first();

        if ($bestBlock) {
            // Allocate memory block
            $bestBlock->allocated = true;
            $bestBlock->allocated_to = "Process (Size: {$processSize})";
            $bestBlock->save();

            return back()->with('success', 'Memory allocated successfully!');
        }

        return back()->with('error', 'No suitable memory block found!');
    }

    // Release a memory block
    public function release($id)
    {
        $block = MemoryBlock::findOrFail($id);
        $block->allocated = false;
        $block->allocated_to = null;
        $block->save();

        return back()->with('success', 'Memory block released!');
    }
}
