export const BoardRoutes = {
    load: "",
    pin: "",
    move: "",
    delete: "",
    connections: "",
    sticky: "",
};

function getCsrfToken() {
    return document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content") ?? "";
}

async function request(url, method, body) {
    const response = await fetch(url, {
        method,
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": getCsrfToken(),
        },
        body: body !== undefined ? JSON.stringify(body) : undefined,
    });

    if (!response.ok) {
        throw new Error(`Request failed with status ${response.status}`);
    }

    return await response.json();
}

export async function loadBoard(caseId) {
    return await request(BoardRoutes.load, "POST", { caseId });
}

export async function pinEvidence(caseId, payload) {
    return await request(BoardRoutes.pin, "POST", {
        caseId,
        ...payload,
    });
}

export async function moveItem(caseId, itemId, payload) {
    return await request(BoardRoutes.move, "POST", {
        caseId,
        itemId,
        ...payload,
    });
}

export async function deleteItem(caseId, itemId) {
    return await request(BoardRoutes.delete, "POST", {
        caseId,
        itemId,
    });
}

export async function saveConnections(caseId, payload) {
    return await request(BoardRoutes.connections, "POST", {
        caseId,
        ...payload,
    });
}

export async function saveSticky(caseId, payload) {
    return await request(BoardRoutes.sticky, "POST", {
        caseId,
        ...payload,
    });
}