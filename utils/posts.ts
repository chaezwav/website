import {extract} from "jsr:@std/front-matter/any";
import {join} from "jsr:@std/path";

export enum Status {
    draft,
    unlisted,
    published,
}

export interface Post {
    slug: string;
    title: string;
    publishedAt: Date;
    content: string;
    status: Status;
    tags: string[];
}

export async function getPosts(): Promise<Post[]> {
    const files = Deno.readDir("./posts");
    const promises = [];
    for await (const file of files) {
        const slug = file.name.replace(".md", "");
        promises.push(getPost(slug));
    }
    const posts = await Promise.all(promises) as Post[];

    return posts.filter((p) => p.status === Status.published).sort((
        a,
        b,
    ) => b.publishedAt.getTime() - a.publishedAt.getTime());
}

export async function getPost(slug: string): Promise<Post | null> {
    let text: string;

    try {
        text = await Deno.readTextFile(join("./posts", `${slug}.md`));
    } catch (e) {
        throw new Deno.errors.NotFound(`Post not found: ${slug}`);
    }

    const {attrs, body} = extract(text);

    if (!attrs.tags) {
        attrs.tags = "n/a";
    }

    if (!(attrs.status in Status)) {
        throw new Error(`Invalid status: ${attrs.status}`);
    }

    return {
        slug,
        title: attrs.title,
        publishedAt: new Date(attrs.published_at),
        content: body,
        status: attrs.status,
        tags: attrs.tags,
    };
}
