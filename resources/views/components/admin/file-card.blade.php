@props([
    'case',
    'file',
])

<div class="admin-file-card">
    <div class="admin-file-card__main">
        <div class="admin-file-card__header">
            <div>
                <div class="admin-file-card__section">
                    {{ $file->section ?: 'Unsectioned' }}
                </div>
                <h3 class="admin-file-card__title">
                    {{ $file->title }}
                </h3>
                <div class="admin-file-card__subtitle">
                    {{ $file->category ?: 'Uncategorized' }}
                </div>
            </div>

            <div class="admin-file-card__badges">
                <span class="admin-status-badge {{ $file->locked ? 'admin-status-badge--danger' : 'admin-status-badge--success' }}">
                    {{ $file->locked ? 'Locked' : 'Open' }}
                </span>

                <span class="admin-status-badge {{ $file->public ? 'admin-status-badge--info' : 'admin-status-badge--muted' }}">
                    {{ $file->public ? 'Public' : 'Restricted' }}
                </span>
            </div>
        </div>

        @if($file->description)
            <p class="admin-file-card__description">
                {{ $file->description }}
            </p>
        @endif

        <x-admin.meta-list :items="[
            ['label' => 'Original', 'value' => $file->original_name],
            ['label' => 'Stored', 'value' => $file->file_name],
            ['label' => 'MIME', 'value' => $file->mime_type],
            ['label' => 'Extension', 'value' => $file->extension],
            ['label' => 'Size', 'value' => $file->file_size ? number_format($file->file_size) . ' bytes' : '-'],
            ['label' => 'Downloads', 'value' => $file->download_count ?? 0],
            ['label' => 'Previews', 'value' => $file->preview_count ?? 0],
            ['label' => 'Version', 'value' => $file->version ?? 1],
            ['label' => 'Unlock Event', 'value' => $file->unlock_event],
            ['label' => 'Required Rank', 'value' => $file->required_rank],
            ['label' => 'Clearance', 'value' => $file->required_clearance],
        ]" />

        <div class="admin-file-card__footer">
            <form
                method="POST"
                action="{{ route('admin.case-files.reorder',$case) }}"
                class="admin-file-card__order">
                @csrf
                <input type="hidden" name="files[0][id]" value="{{ $file->id }}">

                <label class="admin-file-card__order-label">
                    Order
                </label>

                <input
                    type="number"
                    name="files[0][display_order]"
                    value="{{ $file->display_order }}"
                    class="admin-file-card__order-input">

                <button type="submit" class="admin-file-card__order-save">
                    Save
                </button>
            </form>

            <div class="admin-file-card__actions">
                <x-admin.icon-button
                    :href="route('admin.case-files.show',[$case,$file])"
                    label="Preview"
                    icon="◫"
                    variant="neutral" />

                <x-admin.icon-button
                    :href="route('admin.case-files.show',[$case,$file])"
                    label="Download"
                    icon="↓"
                    variant="info" />

                <form
                    action="{{ route('admin.case-files.toggle-lock',[$case,$file]) }}"
                    method="POST">
                    @csrf
                    @method('PATCH')

                    <x-admin.icon-button
                        type="submit"
                        :label="$file->locked ? 'Unlock' : 'Lock'"
                        :icon="$file->locked ? '⊝' : '⊕'"
                        variant="warning" />
                </form>

                <x-admin.icon-button
                    :href="route('admin.case-files.edit',[$case,$file])"
                    label="Edit"
                    icon="✎"
                    variant="accent" />

                <form
                    action="{{ route('admin.case-files.destroy',[$case,$file]) }}"
                    method="POST"
                    onsubmit="return confirm('Delete this file?')">
                    @csrf
                    @method('DELETE')

                    <x-admin.icon-button
                        type="submit"
                        label="Delete"
                        icon="×"
                        variant="danger" />
                </form>
            </div>
        </div>
    </div>
</div>