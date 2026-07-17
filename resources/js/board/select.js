import { boardState } from "./state.js";
import { getCanvasElement } from "./canvas.js";

let selectedElement = null;

export function initializeSelection() {
    const canvas = getCanvasElement();

    if (!canvas) {
        return;
    }

    canvas.addEventListener("click", (event) => {
        const item = event.target.closest(".board-item");

        if (item && canvas.contains(item)) {
            selectItem(item);
            return;
        }

        if (event.target === canvas) {
            clearSelection();
        }
    });
}

export function clearSelection() {
    if (selectedElement) {
        selectedElement.classList.remove("board-item-selected");
    }

    selectedElement = null;
    boardState.selectedItem = null;
}

export function selectItem(item) {
    if (!(item instanceof Element)) {
        return;
    }

    if (selectedElement === item) {
        return;
    }

    clearSelection();

    item.classList.add("board-item-selected");
    selectedElement = item;

    boardState.selectedItem =
        item.dataset.itemId ??
        item.dataset.fileId ??
        item.getAttribute("data-item-id") ??
        item.getAttribute("data-file-id") ??
        null;
}