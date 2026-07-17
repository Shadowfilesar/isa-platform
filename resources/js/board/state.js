export const boardState = {
    zoom: 1,
    pan: {
        x: 0,
        y: 0,
    },

    selectedItem: null,

    items: new Map(),

    connections: new Map(),

    stickyNotes: new Map(),

    focusedItem: null,

    dragging: false,

    connecting: false,

    dirty: false,
};

export function setDirty() {
    boardState.dirty = true;
}

export function clearDirty() {
    boardState.dirty = false;
}

export function setSelected(id) {
    boardState.selectedItem = id;
}

export function clearSelection() {
    boardState.selectedItem = null;
}

export function setFocused(id) {
    boardState.focusedItem = id;
}

export function clearFocus() {
    boardState.focusedItem = null;
}

export function resetBoardState() {
    boardState.zoom = 1;

    boardState.pan.x = 0;
    boardState.pan.y = 0;

    boardState.selectedItem = null;

    boardState.items.clear();
    boardState.connections.clear();
    boardState.stickyNotes.clear();

    boardState.focusedItem = null;

    boardState.dragging = false;
    boardState.connecting = false;

    boardState.dirty = false;
}