import { boardState } from "./state.js";

let canvasElement = null;
let focusedElement = null;

export function initializeFocusMode() {
    canvasElement = document.querySelector("#board-canvas");

    if (!canvasElement) {
        return;
    }

    canvasElement.addEventListener("dblclick", (event) => {
        const item = event.target.closest(".board-item");

        if (item && canvasElement.contains(item)) {
            const itemId =
                item.dataset.itemId ??
                item.getAttribute("data-item-id") ??
                item.dataset.fileId ??
                item.getAttribute("data-file-id");

            if (itemId != null) {
                focusItem(itemId);
            }

            return;
        }

        if (event.target === canvasElement) {
            clearFocusMode();
        }
    });
}

export function focusItem(itemId) {
    if (!canvasElement) {
        canvasElement = document.querySelector("#board-canvas");
    }

    if (!canvasElement) {
        return;
    }

    clearFocusMode();

    boardState.focusedItem = itemId;

    canvasElement.classList.add("board-focus-active");

    const items = canvasElement.querySelectorAll(".board-item");

    items.forEach((item) => {
        const currentId =
            item.dataset.itemId ??
            item.getAttribute("data-item-id") ??
            item.dataset.fileId ??
            item.getAttribute("data-file-id");

        if (String(currentId) === String(itemId)) {
            item.classList.add("board-item-focus");
            focusedElement = item;
        } else {
            item.classList.add("board-item-dimmed");
        }
    });
}

export function clearFocusMode() {
    if (!canvasElement) {
        canvasElement = document.querySelector("#board-canvas");
    }

    if (!canvasElement) {
        boardState.focusedItem = null;
        focusedElement = null;
        return;
    }

    canvasElement.classList.remove("board-focus-active");

    canvasElement.querySelectorAll(".board-item").forEach((item) => {
        item.classList.remove("board-item-focus");
        item.classList.remove("board-item-dimmed");
    });

    focusedElement = null;
    boardState.focusedItem = null;
}