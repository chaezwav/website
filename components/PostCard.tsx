import { Post } from "../utils/posts.ts";
import markdownit from "npm:markdown-it@12.0.4";

export function PostCard(props: { post: Post }) {
    const { post } = props;
    const md = markdownit();

    return (
        <div class="postcard">
            <h3>
                {post.title}
            </h3>
            <div >
                <span>
                    <i className="fa-solid fa-clock"></i>{" "}
                    <time>
                        {new Date(post.publishedAt).toLocaleDateString(
                            "en-us",
                            {
                                year: "numeric",
                                month: "long",
                                day: "numeric",
                            },
                        )}
                    </time>
                </span>{" "}
                • {post.tags.map((tag) => (
                <span>
                        <span>
                            <i className="fa-solid fa-hashtag"></i>
                            {tag}
                        </span>
                    </span>
            ))}
            </div>
            <div
                dangerouslySetInnerHTML={{
                    __html: md.render(post.content.slice(0, 180)),
                }}
            />
            <span>
                <i className="fa-solid fa-book"></i>{" "}
                <a
                    href={`/${post.slug}`}
                >
                    <strong>Read more...</strong>
                </a>
            </span>
        </div>
    );
}
