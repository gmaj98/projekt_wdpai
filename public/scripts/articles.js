class ArticleApp {
    constructor(apiUrl) {
        this.apiUrl = apiUrl;
        this.grid = document.getElementById("articleGrid");
        this.loadMoreBtn = document.getElementById("loadMore");
        this.page = 0;
        this.perPage = 6;
        this.articles = [];
    }

    async loadArticles() {
        try {
            const res = await fetch(this.apiUrl);
            const data = await res.json();
            this.articles = data;
            this.render();
        } catch (err) {
            console.error("❌ Błąd ładowania artykułów:", err);
        }
    }

    render() {
        const start = this.page * this.perPage;
        const end = start + this.perPage;
        const slice = this.articles.slice(start, end);

        slice.forEach(a => {
            const card = document.createElement("div");
            card.className = "article-card";

            card.innerHTML = `
              <img src="${a.image_url || 'https://picsum.photos/400/200'}" alt="">
              <div class="content">
                <h3>${a.title}</h3>
                <p>${a.content}</p>
              </div>
            `;

            card.addEventListener("click", () => {
                window.location.href = `/public/views/article.php?id=${a.id}`;
            });

            this.grid.appendChild(card);
        });

        this.page++;

        if (this.page * this.perPage >= this.articles.length) {
            this.loadMoreBtn.style.display = "none";
        }
    }

    bindEvents() {
        this.loadMoreBtn.addEventListener("click", () => this.render());
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const app = new ArticleApp("/backend/api/articles.php");
    app.bindEvents();
    app.loadArticles();
});
