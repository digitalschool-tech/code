/** @type {import('tailwindcss').Config} */
module.exports = {
  purge: [
    './resources/views/**/*.blade.php',
    './resources/css/**/*.css',
  ],
  content: [],
  theme: {
    colors: {
      "white": {
        "900": "#FFFFFF",
        "700": "#F6F6FB",
        "500": "#F1F2F9",
        "300": "#EAEBF5",
        "100": "#E3E6EF"
      },
      "black": {
        "900": "#17182F",
        "700": "#39394F",
        "500": "#6E6E84",
        "300": "#AAAABA",
        "100": "#CED0DD"
      },
      "orange": {
        "900": "#FF7500",
        "500": "#FF7500",
        "300": "#FEAA63",
        "100": "#FFD1AA"
      },
      "midnight": {
        "900": "#021D38",
        "700": "#50657A",
        "600": "#A4ADB7",
        "400": "#B3BBC3",
        "300": "#CCD2D7",
        "200": "#DADEE1",
        "100": "#E5E8EB"
      },
      "red": {
        "100": "#E8003C",
        "200": "#FDE7EC"
       },
      "blue": {
          "100": "#EBF1FF",
          "900": "#0079FF"
      },
      "green": {
        "100" : "#00AD12",
        "200" : "#E8FFEA"
      },
      "purp": {
        "50": "#d09dff",
        "100": "#c693ff",
        "200": "#bc89ff",
        "300": "#b27fff",
        "400": "#a875ff",
        "500": "#9e6bf5",
        "600": "#9461eb",
        "700": "#8a57e1",
        "800": "#804dd7",
        "900": "#7643cd"
      },
      "transparent": "transparent",
      "orange-transparent": "rgba(255, 117, 0, 0.8)",
      "white-transparent": "rgba(255,255,255,0.51)",
      "background-banner": 'rgba(53, 74, 96, 0.03)',
    },
    textColors: {
    },
    extend: {},
  },
  plugins: [],
}
