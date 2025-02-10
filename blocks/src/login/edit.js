import { store as coreDataStore } from "@wordpress/core-data";
import { useSelect } from "@wordpress/data";
import {
  PanelBody,
  SelectControl,
  Spinner,
  TextControl,
  ToolbarButton,
  Flex,
  FlexBlock,
  BaseControl
} from "@wordpress/components";
import { edit, update } from "@wordpress/icons";
/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {
  useBlockProps,
  InspectorControls,
  BlockControls
} from "@wordpress/block-editor";

function usePages(props) {
  const { pages, hasResolved } = useSelect(
    (select) => {
      const selectorArgs = ["postType", "page", { per_page: -1 }];

      return {
        pages: select(coreDataStore).getEntityRecords(...selectorArgs),
        hasResolved: select(coreDataStore).hasFinishedResolution(
          "getEntityRecords",
          selectorArgs
        )
      };
    },
    [props]
  );

  return { pages, hasResolved };
}

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @param {Object}   props               Properties passed to the function.
 * @param {Object}   props.attributes    Available block attributes.
 * @param {Function} props.setAttributes Function that updates individual attributes.
 *
 * @return {Element} Element to render.
 */
export default function Edit(props) {
  const { pages, hasResolved } = usePages(props);
  const options = pages
    ? pages.map((p) => {
        return { value: p.id, label: p.title.raw };
      })
    : [];
  options.unshift({ value: "none", label: "Select a Page" });
  const blockProps = useBlockProps();
  const { attributes, setAttributes } = props;
  const { loginRedirect } = attributes;

  return (
    <div {...blockProps}>
      <InspectorControls>
        <PanelBody title="Settings" initialOpen={true}>
          {hasResolved ? (
            <>
              <SelectControl
                label="Login Redirect"
                value={parseInt(loginRedirect) > 0 ? loginRedirect : "none"}
                options={options}
                onChange={(value) => {
                  setAttributes({ loginRedirect: value });
                }}
              />
            </>
          ) : (
            <div style={{ marginBottom: "10px" }}>
              Loading Patterns
              <Spinner />
            </div>
          )}
        </PanelBody>
      </InspectorControls>
      <form>
        <input type="text" placeholder="Email" />
        <input type="password" placeholder="Password" />
        <div class="remember">
          <label for="remember">
            <input type="checkbox" id="remember" /> Remember me
          </label>
          <a href="#">Forgot password?</a>
        </div>
        <button>LOG IN</button>
      </form>
    </div>
  );
}
