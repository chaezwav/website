import { Handlers, PageProps } from "$fresh/server.ts";
import { getPosts, Post } from "../utils/posts.ts";
import { PostCard } from "../components/PostCard.tsx";

export const handler: Handlers<Post[]> = {
    async GET(_req, ctx) {
        const posts = await getPosts();
        return ctx.render(posts);
    },
};

export default function BlogIndexPage(props: PageProps<Post[]>) {
    const posts = props.data;
    return (
        <main>
            <h1>*ੈ✩‧₊˚ Post Archive</h1>
            <p>
                Welcome! This is a general archive of all the posts on my blog, organized by publication date and visibility!
            </p>
            <div>
                <h2>
                    <i className="fa-solid fa-clock-rotate-left"></i> Posts
                </h2>
                {posts.map((post) => (
                    <p>
                        <time style="font-family: 'Noto Sans Mono', monospace;">
                            {new Date(post.publishedAt).toLocaleDateString(
                                "en-us",
                            )}
                        </time>{" - "}
                        <a href={`/${post.slug}`}>{post.title}</a>
                    </p>
                ))}
                <span><i className="fa-solid fa-house"></i> <a href="/">Return home</a></span>
            </div>
        </main>
    );
}
