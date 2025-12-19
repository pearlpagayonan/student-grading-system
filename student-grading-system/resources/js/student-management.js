// resources/js/student-management.js
document.addEventListener("DOMContentLoaded", function () {
    // Initialize tooltips
    const tooltips = document.querySelectorAll("[data-tooltip]");
    tooltips.forEach((tooltip) => {
        tooltip.addEventListener("mouseenter", showTooltip);
        tooltip.addEventListener("mouseleave", hideTooltip);
    });

    // Initialize data tables sorting
    const tables = document.querySelectorAll(".table.sortable");
    tables.forEach((table) => {
        const headers = table.querySelectorAll("th[data-sort]");
        headers.forEach((header) => {
            header.style.cursor = "pointer";
            header.addEventListener("click", () => {
                sortTable(table, header);
            });
        });
    });
});

function showTooltip(e) {
    const tooltipText = this.getAttribute("data-tooltip");
    const tooltip = document.createElement("div");
    tooltip.className = "tooltip";
    tooltip.textContent = tooltipText;
    tooltip.style.position = "absolute";
    tooltip.style.background = "#333";
    tooltip.style.color = "white";
    tooltip.style.padding = "5px 10px";
    tooltip.style.borderRadius = "4px";
    tooltip.style.fontSize = "12px";
    tooltip.style.zIndex = "1000";
    document.body.appendChild(tooltip);

    const rect = this.getBoundingClientRect();
    tooltip.style.top = rect.top - 30 + "px";
    tooltip.style.left =
        rect.left + rect.width / 2 - tooltip.offsetWidth / 2 + "px";

    this.currentTooltip = tooltip;
}

function hideTooltip() {
    if (this.currentTooltip) {
        this.currentTooltip.remove();
        this.currentTooltip = null;
    }
}

function sortTable(table, header) {
    const column = header.getAttribute("data-sort");
    const isNumeric = header.classList.contains("numeric");
    const isAscending = header.classList.toggle("asc");
    header.classList.toggle("desc", !isAscending);

    const tbody = table.querySelector("tbody");
    const rows = Array.from(tbody.querySelectorAll("tr"));

    rows.sort((a, b) => {
        let aValue = a
            .querySelector(`td:nth-child(${getColumnIndex(header)})`)
            .textContent.trim();
        let bValue = b
            .querySelector(`td:nth-child(${getColumnIndex(header)})`)
            .textContent.trim();

        if (isNumeric) {
            aValue = parseFloat(aValue) || 0;
            bValue = parseFloat(bValue) || 0;
        }

        if (isAscending) {
            return aValue > bValue ? 1 : -1;
        } else {
            return aValue < bValue ? 1 : -1;
        }
    });

    rows.forEach((row) => tbody.appendChild(row));
}

function getColumnIndex(header) {
    return Array.from(header.parentNode.children).indexOf(header) + 1;
}

// Profile picture upload with preview
function previewProfilePicture(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("profilePreview").src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Auto-calculate average grade
function calculateAverage() {
    const gradeInputs = document.querySelectorAll(".grade-input");
    let total = 0;
    let count = 0;

    gradeInputs.forEach((input) => {
        const value = parseFloat(input.value);
        if (!isNaN(value)) {
            total += value;
            count++;
        }
    });

    const average = count > 0 ? total / count : 0;
    document.getElementById("averageGrade").textContent = average.toFixed(2);

    // Update average grade color
    const avgElement = document.getElementById("averageGrade");
    avgElement.className =
        average >= 90
            ? "text-green-600"
            : average >= 80
            ? "text-blue-600"
            : average >= 75
            ? "text-orange-600"
            : "text-red-600";
}
