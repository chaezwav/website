export function Footer() {
    return (
        <footer>
            <p>
                Made by{" "}
                <span class="name">
                    <strong>Koehn</strong>
                </span>{" "}
                with{" "}
                <a href="https://fresh.deno.dev/">
                    <i
                        class="fa-solid fa-lemon"
                        style="color: #f7f3cb;"
                    >
                    </i>
                </a>{" "}
                +{" "}
                <i
                    class="fa-solid fa-heart"
                    style="color: var(--accent-color);"
                >
                </i>
            </p>
        </footer>
    );
}
