import {Head} from "$fresh/runtime.ts";
import type {PageProps} from "$fresh/server.ts";

export default function NotFoundPage({}: PageProps) {
    return (
        <>
            <Head>
                <title>404 :(</title>
            </Head>
            <div>
                <div>
                    <h1><i class="fa-solid fa-fish fa-spin"></i> 404 - Page not found</h1>
                    <p>
                        The page you were looking for doesn't exist.
                    </p>
                    <span><i class="fa-solid fa-house"></i> <a href="/">Return home</a></span>
                </div>
            </div>
        </>
    );
}
