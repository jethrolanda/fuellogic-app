import { store as coreDataStore } from "@wordpress/core-data";
import { useSelect } from "@wordpress/data";
import { PanelBody, SelectControl, Spinner } from "@wordpress/components";
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
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";

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
  const blockProps = useBlockProps();
  const { pages, hasResolved } = usePages(props);
  const options = pages
    ? pages.map((p) => {
        return { value: p.id, label: p.title.raw };
      })
    : [];
  options.unshift({ value: "none", label: "Select a Page" });

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
      <form action="#">
        <label for="has_account">
          <input type="checkbox" id="has_account" /> My company currently has an
          account
        </label>
        <input type="text" placeholder="Company Name" />
        <input type="text" placeholder="First Name" />
        <input type="text" placeholder="Last Name" />
        <input type="email" placeholder="Email Address" />
        <input type="text" placeholder="Mobile Number" />
        <input type="password" placeholder="Password" />
        <div class="remember">
          <label for="terms_conditions_agreement">
            <input type="checkbox" id="terms_conditions_agreement" /> I agree
            with Terms of Service
          </label>
        </div>
        <button>SIGN UP</button>
      </form>
    </div>
  );
}
