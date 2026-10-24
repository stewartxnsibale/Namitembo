(function () {
    "use strict";

    const body = document.body;

    function lockBody(lock) {
        body.classList.toggle("is-locked", lock);
    }

    function initSiteNav() {
        const toggle = document.querySelector("[data-nav-toggle]");
        const links = document.querySelector("[data-site-links]");
        if (!toggle || !links) return;

        toggle.addEventListener("click", function () {
            const open = links.classList.toggle("is-open");
            toggle.setAttribute("aria-expanded", open ? "true" : "false");
        });

        links.querySelectorAll("a").forEach(function (link) {
            link.addEventListener("click", function () {
                links.classList.remove("is-open");
                toggle.setAttribute("aria-expanded", "false");
            });
        });
    }

    function initSidebar() {
        const sidebar = document.querySelector("[data-sidebar]");
        const overlay = document.querySelector("[data-sidebar-overlay]");
        const toggles = document.querySelectorAll("[data-sidebar-toggle]");
        if (!sidebar) return;

        function setOpen(open) {
            sidebar.classList.toggle("is-open", open);
            if (overlay) overlay.classList.toggle("is-visible", open);
            toggles.forEach(function (toggle) {
                toggle.setAttribute("aria-expanded", open ? "true" : "false");
            });
            lockBody(open);
        }

        toggles.forEach(function (toggle) {
            toggle.addEventListener("click", function () {
                setOpen(!sidebar.classList.contains("is-open"));
            });
        });

        if (overlay) {
            overlay.addEventListener("click", function () {
                setOpen(false);
            });
        }

        sidebar.querySelectorAll("a").forEach(function (link) {
            link.addEventListener("click", function () {
                if (window.innerWidth <= 1024) setOpen(false);
            });
        });

        window.addEventListener("resize", function () {
            if (window.innerWidth > 1024 && sidebar.classList.contains("is-open")) {
                setOpen(false);
            }
        });
    }

    function initDropdowns() {
        const dropdowns = Array.from(document.querySelectorAll("[data-dropdown]"));

        dropdowns.forEach(function (dropdown) {
            const trigger = dropdown.querySelector("[data-dropdown-trigger]");
            if (!trigger) return;

            trigger.addEventListener("click", function (event) {
                event.stopPropagation();
                const open = dropdown.classList.contains("is-open");
                closeDropdowns();
                dropdown.classList.toggle("is-open", !open);
                trigger.setAttribute("aria-expanded", !open ? "true" : "false");
            });
        });

        function closeDropdowns() {
            dropdowns.forEach(function (dropdown) {
                dropdown.classList.remove("is-open");
                const trigger = dropdown.querySelector("[data-dropdown-trigger]");
                if (trigger) trigger.setAttribute("aria-expanded", "false");
            });
        }

        document.addEventListener("click", closeDropdowns);
    }

    function initPreviewModal() {
        const modal = document.getElementById("materialPreviewModal");
        if (!modal) return;

        const previewBody = modal.querySelector("[data-preview-body]");
        const previewTitle = modal.querySelector("[data-preview-title]");
        const previewDescription = modal.querySelector("[data-preview-description]");
        const previewType = modal.querySelector("[data-preview-type]");
        const openLink = modal.querySelector("[data-preview-open]");
        const downloadLink = modal.querySelector("[data-preview-download]");
        const closeButtons = modal.querySelectorAll("[data-preview-close]");
        let lastTrigger = null;

        const labels = {
            pdf: "PDF document",
            video: "Video",
            image: "Image",
            presentation: "Presentation",
            document: "Document"
        };

        function setLink(link, url) {
            if (!link) return;
            if (url) {
                link.href = url;
                link.removeAttribute("hidden");
            } else {
                link.setAttribute("hidden", "hidden");
            }
        }

        function fallback(title) {
            return [
                '<div class="preview-fallback">',
                '<div class="empty-icon"><svg class="icon"><use href="#icon-file"></use></svg></div>',
                "<h3>Preview unavailable</h3>",
                "<p>This file type cannot be displayed in the browser. You can still open or download “" + title + "” using the buttons below.</p>",
                "</div>"
            ].join("");
        }

        function openPreview(trigger) {
            const url = trigger.getAttribute("data-preview-url");
            const type = trigger.getAttribute("data-preview-type") || "document";
            const title = trigger.getAttribute("data-preview-title") || "Learning resource";
            const description = trigger.getAttribute("data-preview-description") || "";
            const openUrl = trigger.getAttribute("data-preview-open-url") || url;
            const downloadUrl = trigger.getAttribute("data-preview-download-url") || url;

            lastTrigger = trigger;
            previewTitle.textContent = title;
            previewDescription.textContent = description;
            previewType.textContent = labels[type] || "Resource";
            previewType.className = "badge type-" + type;
            previewBody.innerHTML = "";

            let element;

            if (type === "pdf") {
                element = document.createElement("iframe");
                element.src = url;
                element.title = title;
                element.setAttribute("loading", "lazy");
            } else if (type === "video") {
                element = document.createElement("video");
                element.src = url;
                element.controls = true;
                element.autoplay = true;
                element.playsInline = true;
            } else if (type === "image") {
                element = document.createElement("img");
                element.src = url;
                element.alt = title;
            } else {
                previewBody.innerHTML = fallback(title);
            }

            if (element) previewBody.appendChild(element);

            setLink(openLink, openUrl);
            setLink(downloadLink, downloadUrl);

            modal.classList.add("is-open");
            modal.setAttribute("aria-hidden", "false");
            lockBody(true);

            const closeButton = modal.querySelector("[data-preview-close-button]");
            if (closeButton) closeButton.focus();
        }

        function closePreview() {
            modal.classList.remove("is-open");
            modal.setAttribute("aria-hidden", "true");
            previewBody.innerHTML = "";
            lockBody(false);
            if (lastTrigger) lastTrigger.focus();
        }

        document.addEventListener("click", function (event) {
            const trigger = event.target.closest("[data-preview-url]");
            if (trigger) {
                event.preventDefault();
                openPreview(trigger);
            }
        });

        closeButtons.forEach(function (button) {
            button.addEventListener("click", closePreview);
        });

        document.addEventListener("keydown", function (event) {
            if (event.key === "Escape" && modal.classList.contains("is-open")) {
                closePreview();
            }
        });
    }

    function initFileDrop() {
        document.querySelectorAll("[data-file-drop]").forEach(function (drop) {
            const input = drop.querySelector("input[type=file]");
            const fileName = drop.querySelector("[data-file-name]");
            const defaultText = fileName ? fileName.textContent : "";
            if (!input) return;

            function updateName() {
                if (!fileName) return;
                if (input.files && input.files.length) {
                    fileName.textContent = input.files[0].name;
                    fileName.removeAttribute("hidden");
                } else {
                    fileName.textContent = defaultText;
                }
            }

            ["dragenter", "dragover"].forEach(function (name) {
                drop.addEventListener(name, function (event) {
                    event.preventDefault();
                    drop.classList.add("is-dragging");
                });
            });

            ["dragleave", "drop"].forEach(function (name) {
                drop.addEventListener(name, function (event) {
                    event.preventDefault();
                    drop.classList.remove("is-dragging");
                });
            });

            drop.addEventListener("drop", function (event) {
                if (event.dataTransfer && event.dataTransfer.files.length) {
                    input.files = event.dataTransfer.files;
                    updateName();
                }
            });

            input.addEventListener("change", updateName);
        });
    }

    function initConfirmForms() {
        document.querySelectorAll("form[data-confirm]").forEach(function (form) {
            form.addEventListener("submit", function (event) {
                if (!window.confirm(form.getAttribute("data-confirm"))) {
                    event.preventDefault();
                }
            });
        });
    }

    function initDismissibles() {
        document.querySelectorAll("[data-dismiss]").forEach(function (button) {
            button.addEventListener("click", function () {
                const target = button.closest("[data-dismissible]");
                if (target) target.remove();
            });
        });
    }

    function initPasswordToggles() {
        document.querySelectorAll("[data-password-toggle]").forEach(function (button) {
            const targetId = button.getAttribute("data-password-toggle");
            const input = document.getElementById(targetId);
            if (!input) return;

            button.addEventListener("click", function () {
                const show = input.type === "password";
                input.type = show ? "text" : "password";
                button.setAttribute("aria-label", show ? "Hide password" : "Show password");
                button.setAttribute("aria-pressed", show ? "true" : "false");
            });
        });
    }

    function initYear() {
        document.querySelectorAll("[data-current-year]").forEach(function (node) {
            node.textContent = new Date().getFullYear();
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        initSiteNav();
        initSidebar();
        initDropdowns();
        initPreviewModal();
        initFileDrop();
        initConfirmForms();
        initDismissibles();
        initPasswordToggles();
        initYear();
    });
})();
