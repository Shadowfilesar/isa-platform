import "./state.js";
import "./api.js";

import { initializeCanvas } from "./canvas.js";
import { initializeDragAndDrop } from "./drag.js";
import { initializeEvidenceLibrary } from "./evidence.js";
import { initializeAutosave } from "./autosave.js";
import { initializeMove } from "./move.js";
import { initializeSelection } from "./select.js";
import { initializeFocusMode } from "./focus.js";
import { initializeConnections } from "./connection.js";
import { initializeToolbar } from "./toolbar.js";

document.addEventListener("DOMContentLoaded", () => {
    const canvas = document.querySelector("#board-canvas");

    if (!canvas) {
        return;
    }

    const evidenceList = document.querySelector("#board-evidence-list");
    const inspector = document.querySelector("#board-inspector");

    void evidenceList;
    void inspector;

    initializeCanvas();
    initializeEvidenceLibrary();
    initializeDragAndDrop();
    initializeAutosave();

    initializeMove();
    initializeSelection();
    initializeFocusMode();
    initializeConnections();
    initializeToolbar();
});