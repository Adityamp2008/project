<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::orderBy('name')->paginate(10);
        return view('pages.admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('pages.admin.rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name',
            'description' => 'nullable|string',
        ]);

        Room::create($request->only(['name', 'description']));

        return redirect()->route('rooms.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function edit(Room $room)
    {
        return view('pages.admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rooms,name,' . $room->id,
            'description' => 'nullable|string',
        ]);

        $room->update($request->only(['name', 'description']));

        return redirect()->route('rooms.index')->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Ruangan berhasil dihapus.');
    }
}

