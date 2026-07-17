import { boardState } from "./state.js";
import { getCanvasElement } from "./canvas.js";
import { getMousePosition } from "./utils.js";

let activeItem = null;
let pointerOffset = { x: 0, y: 0 };

export function initializeMove() {
    const canvas = getCanvasElement();

    if (!canvas) {
        return;
    }

    canvas.addEventListener("mousedown", onMouseDown);
    document.addEventListener("mousemove", onMouseMove);
    document.addEventListener("mouseup", onMouseUp);
}

function onMouseDown(event) {
    const canvas = getCanvasElement();

    if (!canvas) {
        return;
    }

    const item = event.target.closest(".board-item");

    if (!item || !canvas.contains(item)) {
        return;
    }

    const mouse = getMousePosition(event, canvas);

    const left = parseFloat(item.style.left) || 0;
    const top = parseFloat(item.style.top) || 0;

    activeItem = item;

    pointerOffset.x = mouse.x - left;
    pointerOffset.y = mouse.y - top;

    boardState.dragging = true;

    event.preventDefault();
}

function onMouseMove(event) {
    if (!boardState.dragging || !activeItem) {
        return;
    }

    const canvas = getCanvasElement();

    if (!canvas) {
        return;
    }

    const mouse = getMousePosition(event, canvas);

    activeItem.style.left = `${mouse.x - pointerOffset.x}px`;
    activeItem.style.top = `${mouse.y - pointerOffset.y}px`;
}

function onMouseUp() {
    if (!activeItem) {
        return;
    }

    activeItem = null;

    boardState.dragging = false;
    boardState.dirty = true;
}