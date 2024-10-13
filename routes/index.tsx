import {Handlers, PageProps} from "$fresh/server.ts";
import {getPosts, Post} from "../utils/posts.ts";
import {PostCard} from "../components/PostCard.tsx";

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
            <h1>ദ്ദി ˉ͈̀꒳ˉ͈́ )✧ Koehn's Blog</h1>
            <p>Welcome! This is my blog that I may or may not update ever... This was mostly an experiment to get better
                at programming and see what I was capable of, but we'll see where it goes.</p>
            <div>
                <h2><i class="fa-solid fa-newspaper"></i> Recent posts</h2>
                {posts.map((post) => <PostCard post={post}/>)}
            </div>
        </main>
    );
}
