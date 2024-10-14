export interface BannerProps {
  title: string;
  content: string;
}

export function Banner(props: { banner: BannerProps }) {
  const { banner } = props;

  return (
    <div class="banner">
      <h3>{banner.title}</h3>
      <p>{banner.content}</p>
    </div>
  );
}
