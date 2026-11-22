// ==========================================================
// Plugins :: zeimoto :: Blocks :: Panel :: Caption
// ==========================================================
//
// Keeps media caption formatting at the top of its block.
//
// ==========================================================

import { h } from "vue"

export default {
  extends: "k-block-figure-caption",
  emits: ["input"],
  render() {
    return h("figcaption", { class: ["k-block-figure-caption", "zeimoto-blocks-caption-fixed"] }, [
      h("k-writer-input", {
        disabled: this.disabled,
        inline: true,
        marks: this.marks,
        spellcheck: false,
        toolbar: { inline: false },
        value: this.value,
        onInput: (value) => this.$emit("input", value),
      }),
    ])
  },
}
