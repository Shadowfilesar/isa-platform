document.addEventListener("DOMContentLoaded", () => {

    const library = document.querySelectorAll(".board-library-card");
    const canvas = document.getElementById("board-items");

    if (!canvas) return;

    let dragged = null;

    library.forEach(card => {

        card.addEventListener("dragstart", e => {

            dragged = card;

            e.dataTransfer.effectAllowed = "copy";

        });

    });

    canvas.addEventListener("dragover", e => {

        e.preventDefault();

    });

    canvas.addEventListener("drop", e => {

        e.preventDefault();

        if (!dragged) return;

        const clone = dragged.cloneNode(true);

        clone.classList.remove("cursor-grab");

        clone.classList.add("cursor-move");

        clone.draggable = false;

        clone.style.position = "absolute";

        clone.style.left = e.offsetX + "px";

        clone.style.top = e.offsetY + "px";

        clone.style.width = "240px";

        clone.style.zIndex = 10;

        enableDragging(clone);

        canvas.appendChild(clone);

        dragged = null;

    });

    function enableDragging(el) {

        let startX = 0;
        let startY = 0;
        let dragging = false;

        el.addEventListener("mousedown", e => {

            dragging = true;

            startX = e.clientX - el.offsetLeft;
            startY = e.clientY - el.offsetTop;

            el.style.zIndex = 999;

        });

        document.addEventListener("mousemove", e => {

            if (!dragging) return;

            el.style.left = (e.clientX - startX) + "px";
            el.style.top = (e.clientY - startY) + "px";

        });

        document.addEventListener("mouseup", () => {

            dragging = false;

        });

    }

});