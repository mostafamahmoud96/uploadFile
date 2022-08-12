@extends('layouts.app')
@section('content')

@if ($errors->any())
    <div role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="md:flex md:justify-center mb-6">
        <form method="Post" action="{{ route('upload_file') }}" enctype="multipart/form-data"
            class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Name
                </label>
                <input type="text"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="file">File</label>
                <input type="file" name="file"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
            </div>
            <button class="bg-blue-500 hover:bg-blue-700 text-blue font-bold py-2 px-4 rounded-full">submit</button>
        </form>
    </div>
@endsection
