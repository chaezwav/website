import {Handlers, PageProps} from "$fresh/server.ts";
import {getPost, Post, Status} from "../utils/posts.ts";
import markdownit from "npm:markdown-it@12.0.4";
import {Head} from "$fresh/runtime.ts";

export const handler: Handlers<Post> = {
    async GET(_req, ctx) {
        let post: Post | null;

        try {
            post = await getPost(ctx.params.slug);

            if (post === null) {
                return ctx.renderNotFound();
            }
        } catch (e) {
            return ctx.renderNotFound();
        }
        return ctx.render(post);
    },
};

export default function PostPage(props: PageProps<Post>) {
    const md = markdownit();

    const post = props.data;

    let statusSymbol: string;

    switch (post.status) {
        case Status.draft:
            statusSymbol = "fa-file-pen";
            break;
        case Status.unlisted:
            statusSymbol = "fa-eye-slash";
            break;
        case Status.published:
            statusSymbol = "fa-newspaper";
            break;
        default:
            statusSymbol = "fa-question";
            break;
    }

    return (
        <>
            <Head>
                <title>{post.title}</title>
            </Head>
            <main>
                <h1><i className={'fa-solid ' + statusSymbol}></i> {post.title}</h1>
                <time>
                    {new Date(post.publishedAt).toLocaleDateString("en-us", {
                        year: "numeric",
                        month: "long",
                        day: "numeric",
                    })}
                </time>
                <div
                    dangerouslySetInnerHTML={{
                        __html: md.render(post.content),
                    }}
                />
                <span>
                  <i className="fa-solid fa-house"></i> <a href="/">Return home</a>
                </span>
            </main>
        </>
    );
}
