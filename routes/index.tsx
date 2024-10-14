import { Handlers, PageProps } from "$fresh/server.ts";
import { getPosts, Post } from "../utils/posts.ts";
import { PostCard } from "../components/PostCard.tsx";
import { Banner, BannerProps } from "../components/Banner.tsx";
import { format } from "jsr:@std/datetime";

export const handler: Handlers<Post[]> = {
  async GET(_req, ctx) {
    const posts = await getPosts();
    return ctx.render(posts);
  },
};

export default function BlogIndexPage(props: PageProps<Post[]>) {
  const posts = props.data;

  const banner: BannerProps = {
    title: "Warning: Early Development",
    content:
      "This site is still in early development and may not be fully functional.",
    icon: "fa-triangle-exclamation",
  };

  return (
    <main>
      <h1>ദ്ദി ˉ͈̀꒳ˉ͈́ )✧ Koehn's Blog</h1>
      <Banner banner={banner} />
      <p>
        Welcome! This is my blog that I may or may not update ever... This was
        mostly an experiment to get better at programming and see what I was
        capable of, but we'll see where it goes.
      </p>
      <div>
        <h2>
          <i className="fa-solid fa-stopwatch"></i> Latest post
        </h2>
        <PostCard post={posts[0]} />
      </div>
      <div>
        <h2>
          <i className="fa-solid fa-satellite-dish"></i> Recent posts
        </h2>
        {posts.slice(1, 5).map((post) => (
          <p>
            <time>
              {format(new Date(post.publishedAt), "yyyy-MM-dd")}
            </time>
            {" - "}
            <a href={`/${post.slug}`}>{post.title}</a>
          </p>
        ))}
        {posts.length - 1 === 0
          ? (
            <p class="name">
              <i className="fa-solid fa-heart-crack"></i> No posts found...
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
              <i className="fa-solid fa-clock-rotate-left"></i>{" "}
              <a href="/archive">See all posts</a>
            </span>
          )}
      </div>
    </main>
  );
}
