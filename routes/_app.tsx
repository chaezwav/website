import { type PageProps } from "$fresh/server.ts";
import { Footer } from "../components/Footer.tsx";
import { Nav } from "../components/Nav.tsx";

export default function App({ Component }: PageProps) {
  return (
    <html>
      <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Koehn's Blog</title>
        <link rel="stylesheet" href="styles.css" />
        <link
          rel="icon"
          type="image/x-icon"
          href={`${Deno.env.get("ENVIRONMENT")}.ico`}
        />
      </head>
      <body>
        <Nav />
        <Component />
        <Footer />
      </body>
      <script
        src="https://kit.fontawesome.com/4c53100ac3.js"
        crossorigin="anonymous"
      >
      </script>
    </html>
  );
}
