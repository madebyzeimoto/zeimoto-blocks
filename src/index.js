// ==========================================================
// Plugins :: zeimoto :: Blocks :: Panel
// ==========================================================
//
// Registers the modular Panel extensions for zeimoto blocks.
//
// ==========================================================

import "./index.css"
import quote from "./blocks/quote.js"

panel.plugin("zeimoto/blocks", {
  components: {
    "k-block-type-quote": quote,
  },
})
