<?php

namespace App\Console;

use Illuminate\Support\Facades\Storage;

trait Lockable {

    public function lock($lockName) {
        if (!Storage::disk('locks')->exists($lockName)) {
            Storage::disk('locks')->put($lockName, '1');
        }
    }

    public function unlock($lockName) {
        if (Storage::disk('locks')->exists($lockName)) {
            Storage::disk('locks')->delete($lockName);
        }
    }

    public function isLocked($lockName) {
        return Storage::disk('locks')->exists($lockName);
    }
}