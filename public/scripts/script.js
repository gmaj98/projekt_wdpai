class Slope {
    constructor(data) {
        this.id = data.id;
        this.name = data.name;
        this.location = data.location;
        this.latitude = Number(data.latitude);
        this.longitude = Number(data.longitude);
        this.levels = {
            green: !!data.level_green,
            blue: !!data.level_blue,
            red: !!data.level_red,
            black: !!data.level_black
        };
        this.status = data.status ? "open" : "closed";
    }

    renderButton(onClick) {
        const li = document.createElement("li");
        const btn = document.createElement("button");


        btn.textContent = this.name + " ";

        if (this.levels.green) btn.textContent += "🟢";
        if (this.levels.blue) btn.textContent += "🔵";
        if (this.levels.red) btn.textContent += "🔴";
        if (this.levels.black) btn.textContent += "⚫";


        btn.addEventListener("click", () => onClick(this));


        li.dataset.levels = Object.entries(this.levels)
            .filter(([_, v]) => v)
            .map(([k]) => k)
            .join(",");
        li.dataset.status = this.status;

        li.appendChild(btn);
        return li;
    }
}

class SlopeApp {
    constructor(apiUrl) {
        this.apiUrl = apiUrl;
        this.slopes = [];
        this.slopeList = document.getElementById("slopeList");
        this.searchInput = document.getElementById("searchInput");
        this.filterDots = document.querySelectorAll(".filters .dot");
        this.mapFrame = document.querySelector(".map iframe");
    }

    async load() {
        try {
            const res = await fetch(this.apiUrl);
            const data = await res.json();
            this.slopes = data.map(d => new Slope(d));
            this.render();
        } catch (err) {
            console.error("❌ Błąd pobierania stoków:", err);
        }
    }

    render() {
        this.slopeList.innerHTML = "";
        this.slopes.forEach(slope => {
            const li = slope.renderButton(this.showOnMap.bind(this));
            this.slopeList.appendChild(li);
        });
        this.filter(); 
    }

    showOnMap(slope) {
        if (!this.mapFrame || isNaN(slope.latitude) || isNaN(slope.longitude)) {
            console.error("❌ Brak współrzędnych dla stoku:", slope.name);
            return;
        }
        const lat = slope.latitude;
        const lon = slope.longitude;

        const delta = 0.01;
        const bbox = `${lon - delta},${lat - delta},${lon + delta},${lat + delta}`;
        const url = `https://www.openstreetmap.org/export/embed.html?bbox=${bbox}&layer=mapnik&marker=${lat},${lon}`;

        console.log("🌍 Ustawiam mapę na:", url);
        this.mapFrame.src = url;
    }

    getActiveSets() {
        const levels = new Set();
        const statuses = new Set();
        document.querySelectorAll(".filters .dot.active").forEach(d => {
            if (d.dataset.level) levels.add(d.dataset.level.toLowerCase());
            if (d.dataset.status) statuses.add(d.dataset.status.toLowerCase());
        });
        return { levels, statuses };
    }

    filter() {
        const q = this.searchInput.value.trim().toLowerCase();
        const { levels, statuses } = this.getActiveSets();

        this.slopeList.querySelectorAll("li").forEach(li => {
            const name = li.textContent.trim().toLowerCase();

            const liLevels = (li.dataset.levels || "")
                .split(",")
                .map(s => s.trim().toLowerCase())
                .filter(Boolean);

            const liStatus = (li.dataset.status || "").trim().toLowerCase();

            const matchText = !q || name.includes(q);
            const matchLevels = levels.size === 0 || liLevels.some(l => levels.has(l));
            const matchStatus = statuses.size === 0 || statuses.has(liStatus);

            li.style.display = (matchText && matchLevels && matchStatus) ? "" : "none";
        });
    }

    bindEvents() {
        if (this.searchInput) {
            this.searchInput.addEventListener("input", () => this.filter());
        }
        this.filterDots.forEach(d => {
            d.addEventListener("click", () => {
                d.classList.toggle("active");
                this.filter();
            });
        });
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const app = new SlopeApp("/backend/api/slopes.php");
    app.bindEvents();
    app.load();
});
