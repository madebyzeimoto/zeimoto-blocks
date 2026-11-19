// ==========================================================
// Plugins :: zeimoto :: Blocks :: Panel :: Caption
// ==========================================================
//
// Keeps media caption formatting at the top of its block.
//
// ==========================================================

export default {
  extends: "k-block-figure-caption",
  render(h) {
    return h("figcaption", { class: ["k-block-figure-caption", "zeimoto-blocks-caption-fixed"] }, [
      h("k-writer-input", {
        attrs: {
          disabled: this.disabled,
          inline: true,
          marks: this.marks,
          spellcheck: false,
          toolbar: { inline: false },
          value: this.value,
        },
        on: { input: (value) => this.$emit("input", value) },
      }),
    ])
  },
}
