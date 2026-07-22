@extends('layouts.admin')

@section('title', 'Case Files')

@section('admin-content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white">Case Files</h1>
            <p class="mt-2 text-slate-400">Manage files for <span class="text-amber-400">{{ $case->title }}</span>.</p>
        </div>

        <a href="{{ route('admin.case-files.create', $case) }}" class="rounded-lg bg-amber-600 px-5 py-3 font-semibold text-white hover:bg-amber-500">
            Upload File
        </a>
    </div>

    <div class="executive-card overflow-hidden">
        <div class="border-b border-slate-800 p-6">
            @if($files->count())
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-900">
                            <tr>
                                <th class="p-4 text-left text-sm font-semibold text-slate-300">Preview</th>
                                <th class="p-4 text-left text-sm font-semibold text-slate-300">Title</th>
                                <th class="p-4 text-left text-sm font-semibold text-slate-300">Category</th>
                                <th class="p-4 text-left text-sm font-semibold text-slate-300">Section</th>
                                <th class="p-4 text-left text-sm font-semibold text-slate-300">Display Order</th>
                                <th class="p-4 text-left text-sm font-semibold text-slate-300">Status</th>
                                <th class="p-4 text-right text-sm font-semibold text-slate-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($files as $index => $file)
                                @php
                                    $extension = strtolower($file->extension ?? pathinfo($file->file_path ?? '', PATHINFO_EXTENSION));
                                    $filePath = $file->file_path ?? $file->filepath ?? null;
                                    $fileUrl = $filePath ? asset($filePath) : null;
                                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg']);
                                    $isPdf = $extension === 'pdf';
                                    $isVideo = in_array($extension, ['mp4', 'mov', 'avi', 'mkv', 'webm', 'm4v']);
                                    $isAudio = in_array($extension, ['mp3', 'wav', 'ogg', 'm4a', 'aac', 'flac']);
                                    $isArchive = in_array($extension, ['zip', 'rar', '7z', 'tar', 'gz']);
                                    $isDocument = in_array($extension, ['doc', 'docx', 'txt', 'rtf', 'xls', 'xlsx', 'csv', 'ppt', 'pptx']);
                                @endphp
                                <tr class="border-t border-slate-800 align-middle">
                                    <td class="p-4">
                                        <div class="flex h-16 w-16 items-center justify-center overflow-hidden rounded-xl border border-slate-700 bg-slate-900">
                                            @if($isImage && $fileUrl)
                                                <img src="{{ $fileUrl }}" alt="{{ $file->title }}" class="h-full w-full object-cover">
                                            @elseif($isPdf)
                                                <span class="text-xs font-bold uppercase tracking-wide text-red-300">PDF</span>
                                            @elseif($isVideo)
                                                <span class="text-xs font-bold uppercase tracking-wide text-blue-300">Video</span>
                                            @elseif($isAudio)
                                                <span class="text-xs font-bold uppercase tracking-wide text-purple-300">Audio</span>
                                            @elseif($isArchive)
                                                <span class="text-xs font-bold uppercase tracking-wide text-yellow-300">Archive</span>
                                            @elseif($isDocument)
                                                <span class="text-xs font-bold uppercase tracking-wide text-emerald-300">Doc</span>
                                            @else
                                                <span class="text-xs font-bold uppercase tracking-wide text-slate-300">File</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="p-4">
                                        <div class="text-base font-bold text-white">{{ $file->title }}</div>
                                        @if(!empty($extension))
                                            <div class="mt-1 text-xs uppercase tracking-wide text-slate-500">{{ $extension }}</div>
                                        @endif
                                    </td>

                                    <td class="p-4">
                                        <span class="inline-flex rounded-full bg-blue-950 px-3 py-1 text-xs font-semibold text-blue-300">
                                            {{ $file->category }}
                                        </span>
                                    </td>

                                    <td class="p-4">
                                        <span class="inline-flex rounded-full bg-slate-800 px-3 py-1 text-xs font-medium text-slate-200">
                                            {{ $file->section }}
                                        </span>
                                    </td>

                                    <td class="p-4">
                                        <input type="hidden" form="reorder-files-form" name="files[{{ $index }}][id]" value="{{ $file->id }}">
                                        <input
                                            type="number"
                                            form="reorder-files-form"
                                            name="files[{{ $index }}][display_order]"
                                            value="{{ old('files.' . $index . '.display_order', $file->display_order) }}"
                                            class="w-28 rounded-lg border border-slate-700 bg-slate-900 px-3 py-2 text-white focus:border-amber-500 focus:outline-none">
                                    </td>

                                    <td class="p-4">
                                        @if($file->locked)
                                            <span class="rounded-full bg-red-900 px-3 py-1 text-xs font-semibold text-red-300">Locked</span>
                                        @else
                                            <span class="rounded-full bg-green-900 px-3 py-1 text-xs font-semibold text-green-300">Available</span>
                                        @endif
                                    </td>

                                    <td class="p-4">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('admin.case-files.edit', [$case, $file]) }}" class="rounded-lg bg-amber-600 px-4 py-2 text-white hover:bg-amber-500">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.case-files.toggle-lock', [$case, $file]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="rounded-lg bg-slate-700 px-4 py-2 text-white hover:bg-slate-600">
                                                    {{ $file->locked ? 'Unlock' : 'Lock' }}
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.case-files.destroy', [$case, $file]) }}" method="POST" onsubmit="return confirm('Delete this file?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-lg bg-red-700 px-4 py-2 text-white hover:bg-red-600">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <form id="reorder-files-form" action="{{ route('admin.case-files.reorder', $case) }}" method="POST" class="mt-6 flex justify-end">
                    @csrf
                    <button type="submit" class="rounded-lg bg-blue-600 px-5 py-3 font-semibold text-white hover:bg-blue-500">
                        Save Order
                    </button>
                </form>
            @else
                <div class="flex flex-col items-center justify-center rounded-2xl border border-dashed border-slate-700 bg-slate-900/40 px-6 py-16 text-center">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-slate-800 text-2xl text-slate-300">
                        📁
                    </div>
                    <h3 class="mt-5 text-xl font-bold text-white">No case files yet</h3>
                    <p class="mt-2 max-w-md text-sm text-slate-400">
                        This case does not have any uploaded files yet. Add the first file to start organizing investigation materials.
                    </p>
                    <a href="{{ route('admin.case-files.create', $case) }}" class="mt-6 rounded-lg bg-amber-600 px-5 py-3 font-semibold text-white hover:bg-amber-500">
                        Upload File
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection