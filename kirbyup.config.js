// ==========================================================
// Plugins :: zeimoto :: Blocks :: Kirbyup
// ==========================================================
//
// Keeps the Panel development server on IPv4 loopback so the
// generated Kirby loader can reliably import its live module.
//
// ==========================================================

import { defineConfig } from "kirbyup/config"

export default defineConfig({
  vite: {
    server: {
      cors: true,
      host: "127.0.0.1",
    },
  },
})
