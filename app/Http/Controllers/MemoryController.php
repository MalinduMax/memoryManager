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

        // For the Buddy System, we will assume sizes are powers of 2
        $block = null;

        // Implementing the Buddy System
        // Find the smallest block that can accommodate the process size
        $block = MemoryBlock::where('allocated', false)
            ->where('size', '>=', $this->nextPowerOfTwo($processSize))
            ->orderBy('size')
            ->first();

        if ($block) {
            // Allocate memory block
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

        return back()->with('success', 'Memory block released!');
    }

    // Helper function to find the next power of two
    private function nextPowerOfTwo($n)
    {
        if ($n && !($n & ($n - 1))) {
            return $n; // n is already a power of 2
        }

        $power = 1;
        while ($power < $n) {
            $power <<= 1; // Shift left to get the next power of 2
        }
        return $power;
    }
}
