import { boardState } from "./state.js";
import { cancelConnection } from "./connection.js";

export function initializeToolbar() {
    const selectButton = document.querySelector("#tool-select");
    const connectButton = document.querySelector("#tool-connect");
    const noteButton = document.querySelector("#tool-note");
    const zoomInButton = document.querySelector("#zoom-in");
    const zoomOutButton = document.querySelector("#zoom-out");
    const zoomResetButton = document.querySelector("#zoom-reset");

    if (selectButton) {
        selectButton.addEventListener("click", () => {
            boardState.connecting = false;
            cancelConnection();
        });
    }

    if (connectButton) {
        connectButton.addEventListener("click", () => {
            boardState.connecting = true;
        });
    }

    if (noteButton) {
        noteButton.addEventListener("click", () => {
            document.dispatchEvent(
                new CustomEvent("board:create-sticky")
            );
        });
    }

    if (zoomInButton) {
        zoomInButton.addEventListener("click", () => {
            document.dispatchEvent(
                new CustomEvent("board:zoom-in")
            );
        });
    }

    if (zoomOutButton) {
        zoomOutButton.addEventListener("click", () => {
            document.dispatchEvent(
                new CustomEvent("board:zoom-out")
            );
        });
    }

    if (zoomResetButton) {
        zoomResetButton.addEventListener("click", () => {
            document.dispatchEvent(
                new CustomEvent("board:zoom-reset")
            );
        });
    }
}