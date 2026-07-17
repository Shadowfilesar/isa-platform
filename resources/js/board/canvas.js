let canvasElement = null;
let boardItemsElement = null;
let connectionsLayerElement = null;

export function initializeCanvas() {
    canvasElement = document.getElementById("board-canvas");
    boardItemsElement = document.getElementById("board-items");
    connectionsLayerElement = document.getElementById("board-connections");

    if (!canvasElement || !boardItemsElement) {
        return;
    }

    resizeCanvas();
    centerCanvas();
}

export function getCanvasElement() {
    return canvasElement;
}

export function getBoardItems() {
    return boardItemsElement;
}

export function getConnectionsLayer() {
    return connectionsLayerElement;
}

export function clearCanvas() {
    if (!boardItemsElement) {
        return;
    }

    boardItemsElement.replaceChildren();
}

export function centerCanvas() {
    if (!canvasElement || !boardItemsElement) {
        return;
    }

    const left = Math.max(
        0,
        (boardItemsElement.scrollWidth - canvasElement.clientWidth) / 2
    );

    const top = Math.max(
        0,
        (boardItemsElement.scrollHeight - canvasElement.clientHeight) / 2
    );

    canvasElement.scrollTo({
        left,
        top,
        behavior: "auto",
    });
}

export function resizeCanvas() {
    if (!canvasElement || !boardItemsElement) {
        return;
    }

    // Reserved for future zoom support.
    canvasElement.dataset.canvasReady = "true";
    boardItemsElement.dataset.workspaceReady = "true";
}