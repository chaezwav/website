import type { Metadata } from "next";
// import localFont from "next/font/local";

// const geistSans = localFont({
//   src: "./fonts/GeistVF.woff",
//   variable: "--font-geist-sans",
//   weight: "100 900",
// });
// const geistMono = localFont({
//   src: "./fonts/GeistMonoVF.woff",
//   variable: "--font-geist-mono",
//   weight: "100 900",
// });

export const metadata: Metadata = {
  title: "Koehn Humphries",
  description: "Koehn's personal website",
  icons: {
    icon: `./${process.env.PRODUCTION_STATUS}.favicon.ico`
  }
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {

  console.log(process.env.PRODUCTION_STATUS)

  return (
    <html lang="en">
      <body>
        {children}
      </body>
    </html>
  );
}
