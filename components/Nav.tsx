export function Nav() {
  const destinations = [
    { name: "Home", url: "/" },
    { name: "Post Archive", url: "/archive" },
  ];

  return (
    <span class="navbar">
      {" | "}
      {destinations.map((destination) => (
        <span>
          <a
            href={destination.url}
            class="navbar-item"
          >
            {destination.name}
          </a>
          {" | "}
        </span>
      ))}
    </span>
  );
}
