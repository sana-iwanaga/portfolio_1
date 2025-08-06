import "./bootstrap";
import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.data("bookSearch", () => ({
    keyword: "",
    results: [],
    selected: {
        title: "",
        creator: "",
    },
    async searchBooks() {
        if (this.keyword.trim() === "") return;

        // 🔍 楽天ブックスAPI
        try {
            const rakutenRes = await fetch(
                `https://app.rakuten.co.jp/services/api/BooksBook/Search/20170404?format=json&title=${encodeURIComponent(
                    this.keyword
                )}&applicationId=1023370564471652170`
            );
            const rakutenData = await rakutenRes.json();

            if (rakutenData.Items && rakutenData.Items.length > 0) {
                this.results = rakutenData.Items.map((item) => ({
                    title: item.Item.title,
                    creator: item.Item.author || "不明",
                }));
                return; // 楽天でヒットしたらそこで終了
            }
        } catch (error) {
            console.error("楽天検索失敗:", error);
        }

        // 🔍 NDL API（楽天にヒットしない場合）
        try {
            const ndlRes = await fetch(
                `/books/quicksearch?q=${encodeURIComponent(this.keyword)}`
            );
            const ndlData = await ndlRes.json();
            this.results = ndlData;
        } catch (error) {
            console.error("NDL検索失敗:", error);
            alert("検索に失敗しました。もう一度お試しください。");
        }

        console.log("検索キーワード:", this.keyword);
    },
    selectBook(book) {
        this.selected.title = book.title;
        this.selected.creator = book.creator;
        this.results = []; // 検索結果を非表示に
    },
}));

Alpine.start();
