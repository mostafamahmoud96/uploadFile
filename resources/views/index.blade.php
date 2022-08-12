@extends('layouts.app')

@section('content')
    <div class="pull-right mb-2">
        <a href="{{ route('fileupload_view') }}" class="flex justify-end pr-2">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Upload File</button></a>

    </div>
    @if (count($uploads) > 0)
        <div class="container mt-2">
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg ">

                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">

                    <tr>
                        <th scope="col" class="py-3 px-6">
                            Id</th>
                        <th scope="col" class="py-3 px-6">
                            File Name</th>
                        <th scope="col" class="py-3 px-6">
                            File Path</th>
                        <th scope="col" class="py-3 px-6">
                            File Size</th>
                        <th scope="col" class="py-3 px-6">
                            File extension</th>
                        <th scope="col" class="py-3 px-6">
                            Download</th>
                    </tr>
                    <tbody>

                        @foreach ($uploads as $upload)
                            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                <td class="py-4 px-6">{{ $upload->id }}</td>
                                <td class="py-4 px-6">{{ $upload->name }}</td>
                                <td class="py-4 px-6">{{ $upload->path }}</td>
                                <td class="py-4 px-6">{{ $upload->size }}</td>
                                <td class="py-4 px-6">{{ $upload->extension }}</td>
                                <td class="py-4 px-6"><a class="text-red-600	"
                                        href="{{ route('file_download', $upload->id) }}">Download</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-xl font-bold text-center	text-red-600">No Uploads yet.</p>
    @endif
@endsection
