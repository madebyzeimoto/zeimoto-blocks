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
import lead from "./blocks/lead.js"
import list from "./blocks/list.js"
import quote from "./blocks/quote.js"

panel.plugin("zeimoto/blocks", {
  fields: {
    "zeimoto-blocks-list": "k-list-field",
  },
  components: {
    "k-block-figure-caption": caption,
    "k-block-type-heading": heading,
    "k-block-type-lead": lead,
    "k-block-type-list": list,
    "k-block-type-quote": quote,
  },
})
