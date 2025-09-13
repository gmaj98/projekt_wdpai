async function loadArticle() {
    try {
        const res = await fetch(`/backend/api/articles.php?id=${ARTICLE_ID}`);
        const a = await res.json();

        if (a.error) {
            document.getElementById("articleTitle").textContent = "Artykuł nie znaleziony";
            return;
        }

        document.getElementById("articleImage").src = a.image_url || "https://picsum.photos/800/300";
        document.getElementById("articleTitle").textContent = a.title;
        document.getElementById("articleAuthor").textContent = a.author;
        document.getElementById("articleDate").textContent = a.created_at;
        document.getElementById("articleContent").textContent = a.content;
    } catch (err) {
        console.error("❌ Błąd ładowania artykułu:", err);
    }
}

document.addEventListener("DOMContentLoaded", loadArticle);
