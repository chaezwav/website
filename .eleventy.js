import eleventyPluginPhosphoricons from "eleventy-plugin-phosphoricons";

export default function (eleventyConfig) {
  eleventyConfig.addPassthroughCopy({
    "./public/": "/",
  });
  // Suggested code may be subject to a license. Learn more: ~LicenseLog:3593208491.
  eleventyConfig.addLayoutAlias("info", "layouts/info.njk");
  eleventyConfig.addPlugin(eleventyPluginPhosphoricons, {
    size: 16,
    style: "vertial-align: center;",
  });
  // Suggested code may be subject to a license. Learn more: ~LicenseLog:1284082482.
}

export const config = {
  dir: {
    input: "content", // default: "."
    includes: "../_includes", // default: "_includes" (`input` relative)
  },
};
