import { boardState } from "./state.js";
import { getCanvasElement } from "./canvas.js";

const DRAG_TYPE = "application/x-board-evidence";

export function initializeDragAndDrop() {
    const canvas = getCanvasElement();

    if (!canvas) {
        return;
    }

    initializeEvidenceDragging();
    initializeCanvasDrop(canvas);
    updateEmptyState();
}

function updateEmptyState() {
    const emptyState = document.getElementById("board-empty-state");
    const boardItems = document.getElementById("board-items");

    if (!emptyState || !boardItems) {
        return;
    }

    const hasItems = boardItems.querySelector(".board-item") !== null;

    emptyState.hidden = hasItems;
}

function initializeEvidenceDragging() {
    const cards = document.querySelectorAll(".board-evidence-card");

    cards.forEach((card) => {
        card.draggable = true;

        card.addEventListener("dragstart", (event) => {
            const fileId =
                card.dataset.fileId ??
                card.getAttribute("data-file-id") ??
                "";

            if (!event.dataTransfer) {
                return;
            }

            event.dataTransfer.effectAllowed = "copy";
            event.dataTransfer.setData(DRAG_TYPE, String(fileId));
        });
    });
}

function initializeCanvasDrop(canvas) {
    canvas.addEventListener("dragover", (event) => {
        event.preventDefault();

        if (event.dataTransfer) {
            event.dataTransfer.dropEffect = "copy";
        }
    });

    canvas.addEventListener("drop", (event) => {
        event.preventDefault();

        const boardItems = document.getElementById("board-items");

        if (!boardItems) {
            return;
        }

        const fileId =
            event.dataTransfer?.getData(DRAG_TYPE) ?? "";

        if (!fileId) {
            return;
        }

        const source = document.querySelector(
            `.board-evidence-card[data-file-id="${CSS.escape(String(fileId))}"]`
        );

        if (!source) {
            return;
        }

        const clone = source.cloneNode(true);

        clone.classList.add("board-item");
        clone.draggable = false;

        clone.dataset.fileId = String(fileId);
        clone.style.position = "absolute";

        const canvasRect = canvas.getBoundingClientRect();

        const x =
            event.clientX -
            canvasRect.left +
            canvas.scrollLeft;

        const y =
            event.clientY -
            canvasRect.top +
            canvas.scrollTop;

        clone.style.left = `${x}px`;
        clone.style.top = `${y}px`;
        clone.style.transform = "";

        boardItems.appendChild(clone);

        updateEmptyState();

        boardState.dirty = true;
    });

    document.addEventListener("click", (event) => {
        const removeButton = event.target.closest("[data-board-remove], .board-item-remove");

        if (!removeButton) {
            return;
        }

        const boardItem = removeButton.closest(".board-item");

        if (!boardItem) {
            return;
        }

        boardItem.remove();
        updateEmptyState();
    });
}