import { boardState } from "./state.js";
import { getCanvasElement } from "./canvas.js";

let canvasElement = null;
let svgElement = null;
let pendingItem = null;

export function initializeConnections() {
    canvasElement = getCanvasElement();

    if (!canvasElement) {
        return;
    }

    svgElement = document.querySelector("#board-connections");

    if (!svgElement) {
        return;
    }

    canvasElement.addEventListener("click", (event) => {
        if (!boardState.connecting) {
            return;
        }

        const item = event.target.closest(".board-item");

        if (!item || !canvasElement.contains(item)) {
            return;
        }

        if (!pendingItem) {
            startConnection(item);
        } else {
            finishConnection(item);
        }
    });
}

export function startConnection(item) {
    if (!(item instanceof Element)) {
        return;
    }

    pendingItem = item;
}

export function finishConnection(item) {
    if (!(item instanceof Element) || !pendingItem) {
        return;
    }

    if (item === pendingItem) {
        cancelConnection();
        return;
    }

    const from =
        pendingItem.dataset.itemId ??
        pendingItem.getAttribute("data-item-id") ??
        pendingItem.dataset.fileId ??
        pendingItem.getAttribute("data-file-id");

    const to =
        item.dataset.itemId ??
        item.getAttribute("data-item-id") ??
        item.dataset.fileId ??
        item.getAttribute("data-file-id");

    if (from == null || to == null) {
        cancelConnection();
        return;
    }

    const id =
        typeof crypto !== "undefined" &&
        typeof crypto.randomUUID === "function"
            ? crypto.randomUUID()
            : `connection-${Date.now()}-${Math.random().toString(36).slice(2, 10)}`;

    boardState.connections.set(id, {
        id,
        from,
        to,
    });

    renderConnections();
    cancelConnection();
}

export function cancelConnection() {
    pendingItem = null;
    boardState.connecting = false;
}

export function renderConnections() {
    if (!canvasElement) {
        canvasElement = getCanvasElement();
    }

    if (!svgElement) {
        svgElement = document.querySelector("#board-connections");
    }

    if (!canvasElement || !svgElement) {
        return;
    }

    svgElement.replaceChildren();

    const canvasRect = canvasElement.getBoundingClientRect();

    boardState.connections.forEach((connection) => {
        const fromItem = findBoardItem(connection.from);
        const toItem = findBoardItem(connection.to);

        if (!fromItem || !toItem) {
            return;
        }

        const fromRect = fromItem.getBoundingClientRect();
        const toRect = toItem.getBoundingClientRect();

        const x1 =
            fromRect.left -
            canvasRect.left +
            canvasElement.scrollLeft +
            fromRect.width / 2;

        const y1 =
            fromRect.top -
            canvasRect.top +
            canvasElement.scrollTop +
            fromRect.height / 2;

        const x2 =
            toRect.left -
            canvasRect.left +
            canvasElement.scrollLeft +
            toRect.width / 2;

        const y2 =
            toRect.top -
            canvasRect.top +
            canvasElement.scrollTop +
            toRect.height / 2;

        const line = document.createElementNS(
            "http://www.w3.org/2000/svg",
            "line"
        );

        line.setAttribute("x1", x1);
        line.setAttribute("y1", y1);
        line.setAttribute("x2", x2);
        line.setAttribute("y2", y2);

        svgElement.appendChild(line);
    });
}

function findBoardItem(itemId) {
    const escaped = CSS.escape(String(itemId));

    return (
        canvasElement.querySelector(`[data-item-id="${escaped}"]`) ??
        canvasElement.querySelector(`[data-file-id="${escaped}"]`)
    );
}