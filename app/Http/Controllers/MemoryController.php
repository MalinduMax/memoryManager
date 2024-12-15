<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MemoryBlock;

class MemoryController extends Controller
{
    // Display memory blocks and processes
    public function welcome()
    {
        $blocks = MemoryBlock::all();
        return view('welcome', compact('blocks'));
    }

    // Handle memory allocation dynamically based on remainder
    public function allocate(Request $request)
    {
        $processSize = $request->input('size');
        $block = null;

        // Check if the requested size is a power of 2
        if (!($processSize && !(($processSize) & ($processSize - 1)))) {
            return back()->with('error', 'Requested size must be a power of 2!');
        }

        // Find the smallest block that can accommodate the process size
        $block = MemoryBlock::where('allocated', false)
            ->where('size', '>=', $processSize)
            ->orderBy('size')
            ->first();

        if ($block) {
            // Split the block if it's larger than needed
            while ($block->size > $processSize) {
                $newSize = $block->size / 2;

                // Create a new memory block for the buddy
                MemoryBlock::create([
                    'size' => $newSize,
                    'allocated' => false,
                    'allocated_to' => null,
                ]);

                // Update the current block size
                $block->size = $newSize;
                $block->save();
            }

            // Allocate the memory block
            $block->allocated = true;
            $block->allocated_to = "Process (Size: {$processSize})";
            $block->save();

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

        // Check for buddy block to merge
        $buddyBlock = MemoryBlock::where('size', $block->size)
            ->where('allocated', false)
            ->first();

        if ($buddyBlock) {
            // Merge with buddy block
            $block->delete(); // Remove the current block
            $buddyBlock->size *= 2; // Double the size of the buddy block
            $buddyBlock->save();
        }

        return back()->with('success', 'Memory block released!');
    }
}
