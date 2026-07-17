import { boardState } from "./state.js";

export function initializeAutosave() {
    // Disabled temporarily.
}

export async function saveBoard() {
    console.log("[Board] Autosave");
    boardState.dirty = false;
}