// ==========================================================
// Plugins :: zeimoto :: Blocks :: Panel
// ==========================================================
//
// Registers the modular Panel extensions for zeimoto blocks.
//
// ==========================================================

import "./index.css"
import caption from "./blocks/caption.js"
import heading from "./blocks/heading.js"
import list from "./blocks/list.js"
import quote from "./blocks/quote.js"

panel.plugin("zeimoto/blocks", {
  fields: {
    "zeimoto-blocks-list": { extends: "k-list-field" },
  },
  components: {
    "k-block-figure-caption": caption,
    "k-block-type-heading": heading,
    "k-block-type-list": list,
    "k-block-type-quote": quote,
  },
})
