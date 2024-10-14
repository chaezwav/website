export interface BannerProps {
  title: string;
  content: string;
  icon: string;
}

export function Banner(props: { banner: BannerProps }) {
  const { banner } = props;

  return (
    <div class="banner">
      <h3>
        <i class={"fa-solid " + banner.icon}></i>
        {banner.title}
      </h3>
      <p>{banner.content}</p>
    </div>
  );
}
