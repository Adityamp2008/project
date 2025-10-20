{{-- resources/views/atk/index.blade.php --}}
@extends('layouts.add')
@section('content')
  <div class="p-4">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-xl font-semibold">Daftar ATK</h2>
      <a href="{{ route('atk.create') }}" class="btn">Tambah Item</a>
    </div>

    <table class="min-w-full divide-y">
      <thead class="bg-gray-800 text-white">
        <tr>
          <th class="px-4 py-2">Kode</th>
          <th>Nama</th>
          <th>Stok</th>
          <th>Threshold</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white">
        @foreach($items as $it)
        <tr class="@if($it->isLowStock()) bg-yellow-50 @endif">
          <td class="px-4 py-2">{{ $it->code }}</td>
          <td>{{ $it->name }}</td>
          <td>{{ $it->stock }} {{ $it->unit }}</td>
          <td>{{ $it->low_stock_threshold }}</td>
          <td>
            <a href="{{ route('atk.edit',$it) }}" class="mr-2">Edit</a>
            <form action="{{ route('atk.stock_out',$it) }}" method="post" class="inline-block">
              @csrf
              <input type="hidden" name="quantity" value="1">
              <button class="text-red-600">Keluar 1</button>
            </form>
            <form action="{{ route('atk.stock_in',$it) }}" method="post" class="inline-block ml-2">
              @csrf
              <input type="hidden" name="quantity" value="1">
              <button class="text-green-600">Masuk 1</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="mt-4">{{ $items->links() }}</div>
  </div>
 @endsection
