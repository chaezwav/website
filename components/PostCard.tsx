import {Post} from "../utils/posts.ts";
import markdownit from "npm:markdown-it@12.0.4";

export function PostCard(props: { post: Post }) {
    const {post} = props;
    const md = markdownit();

    return (
        <div class="postcard">
            <h2>
                {post.title}
            </h2>
            {/*<time>*/}
            {/*  {new Date(post.publishedAt).toLocaleDateString("en-us", {*/}
            {/*    year: "numeric",*/}
            {/*    month: "long",*/}
            {/*    day: "numeric",*/}
            {/*  })}*/}
            {/*</time>*/}
            <div
                dangerouslySetInnerHTML={{
                    __html: md.render(post.content.slice(0, 180))
                }}
            />
            <div style="color: var(--accent-color);"><span><i class="fa-solid fa-clock"></i> <time>
          {new Date(post.publishedAt).toLocaleDateString("en-us", {
              year: "numeric",
              month: "long",
              day: "numeric",
          })}
        </time></span> • {post.tags.map((tag) => <span><span><i class="fa-solid fa-hashtag"></i>{tag}</span> </span>)}
            </div>

            <span><i class="fa-solid fa-book"></i> <a class="more"
                                                      href={`/${post.slug}`}> <strong>Read more</strong></a></span>
        </div>
    );
}
