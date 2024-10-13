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

    console.log(posts.length - 1)

    return (
        <main>
            <h1>ദ്ദി ˉ͈̀꒳ˉ͈́ )✧ Koehn's Blog</h1>
            <p>
                Welcome! This is my blog that I may or may not update ever...
                This was mostly an experiment to get better at programming and
                see what I was capable of, but we'll see where it goes.
            </p>
            <div>
                <h2>
                    <i className="fa-solid fa-tower-broadcast"></i> Latest post
                </h2>
                <PostCard post={posts[0]} />
            </div>
            <div>
                <h2>
                    <i className="fa-solid fa-newspaper"></i> Recent posts
                </h2>
                {posts.slice(1, 5).map((post) => (
                    <p>
                        <time style="font-family: 'Noto Sans Mono', monospace;">
                            {new Date(post.publishedAt).toLocaleDateString(
                                "en-us",
                            )}
                        </time>
                        {" - "}
                        <a href={`/${post.slug}`}>{post.title}</a>
                    </p>
                ))}
                {posts.length - 1 === 0
                    ? (
                        <p class="name">
                            <i className="fa-solid fa-heart-crack"></i>{" "}
                            No posts found...
                        </p>
                    )
                    : posts.length - 1 < 6
                    ? (
                            <p className="name">
                                <i className="fa-solid fa-heart-crack"></i>{" "}
                                Welp, that's all the posts...
                            </p>
                        )
                        : (
                            <span>
                            <i className="fa-solid fa-clock-rotate-left"></i>
                                {" "}
                            <a href="/archive">See all posts</a>
                        </span>
                    )}
            </div>
        </main>
    );
}
