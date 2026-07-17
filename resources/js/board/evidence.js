import { boardState } from "./state.js";

let evidenceListElement = null;

export function initializeEvidenceLibrary() {
    evidenceListElement = document.querySelector("#board-evidence-list");

    if (!evidenceListElement) {
        return;
    }

    const cards = evidenceListElement.querySelectorAll(".board-evidence-card");

    cards.forEach((card) => {
        const fileId =
            card.dataset.fileId ??
            card.getAttribute("data-file-id");

        if (!fileId) {
            return;
        }

        boardState.items.set(String(fileId), card);
    });
}

export function renderEvidenceCard(file) {
    const card = document.createElement("div");

    card.className = "board-evidence-card";

    if (file?.id !== undefined && file?.id !== null) {
        card.dataset.fileId = String(file.id);
    }

    const title =
        file?.title ??
        file?.name ??
        file?.filename ??
        "";

    card.textContent = title;

    return card;
}

export function appendEvidence(file) {
    if (!evidenceListElement) {
        evidenceListElement = document.querySelector("#board-evidence-list");
    }

    if (!evidenceListElement) {
        return null;
    }

    const card = renderEvidenceCard(file);

    evidenceListElement.appendChild(card);

    const fileId =
        card.dataset.fileId ??
        card.getAttribute("data-file-id");

    if (fileId) {
        boardState.items.set(String(fileId), card);
    }

    return card;
}

export function removeEvidence(fileId) {
    const key = String(fileId);
    const card = boardState.items.get(key);

    if (!card) {
        return;
    }

    card.remove();
    boardState.items.delete(key);
}

export function findEvidence(fileId) {
    return boardState.items.get(String(fileId)) ?? null;
}