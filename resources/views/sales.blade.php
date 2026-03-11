<x-app-layout>

<x-slot name="header">
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
Data Penjualan Bunga
</h2>
</x-slot>

<div class="py-12">

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

<div class="p-6 text-gray-900">

<h2 class="text-2xl font-bold mb-6">
Dataset Penjualan
</h2>

@if(session('success'))
<div style="color:green; margin-bottom:15px;">
{{ session('success') }}
</div>
@endif

<form action="{{ route('upload.dataset') }}" method="POST" enctype="multipart/form-data" style="margin-bottom:20px;">

@csrf

<input type="file" name="dataset" required>

<button type="submit"
style="background:#2563eb;color:white;padding:6px 12px;border-radius:4px;margin-left:10px;">

Upload Dataset

</button>

</form>

<table class="table-auto w-full border">

<thead>
<tr>

@foreach($header as $head)

<th class="border px-4 py-2 bg-gray-100">
{{ $head }}
</th>

@endforeach

</tr>
</thead>

<tbody>

@foreach($rows as $row)

<tr>

@foreach($row as $cell)

<td class="border px-4 py-2">
{{ $cell }}
</td>

@endforeach

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>

</div>

</x-app-layout>