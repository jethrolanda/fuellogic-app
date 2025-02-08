import { store as coreDataStore } from "@wordpress/core-data";
import { useSelect } from "@wordpress/data";
import {
  PanelBody,
  SelectControl,
  Spinner,
  TextControl,
  Flex,
  FlexBlock,
  BaseControl,
  Button,
  ToolbarButton
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
  InspectorControls,
  BlockControls,
  useBlockProps
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
  const { editMode } = attributes;

  function deleteMenu(indexToDelete) {
    const newData = attributes.data.filter(function (x, index) {
      return index != indexToDelete;
    });
    setAttributes({ data: newData });
  }

  function toggleEditMode() {
    setAttributes({ editMode: !editMode });
  }
  return (
    <div {...blockProps}>
      <BlockControls>
        {editMode ? (
          <ToolbarButton
            icon={update}
            label="View"
            onClick={() => toggleEditMode()}
          />
        ) : (
          <ToolbarButton
            icon={edit}
            label="Edit"
            onClick={() => toggleEditMode()}
          />
        )}
      </BlockControls>
      {editMode ? (
        <Flex>
          <FlexBlock style={{ gap: "20px" }}>
            {attributes.data.map(function (menu, index) {
              return (
                <div>
                  <h4>Menu #{index + 1}</h4>
                  {hasResolved ? (
                    <>
                      <BaseControl help="Only class name example: fa-solid fa-map">
                        <BaseControl.VisualLabel>
                          Fontawesome Class
                        </BaseControl.VisualLabel>
                        <TextControl
                          value={menu?.fa_class}
                          onChange={(newValue) => {
                            const newData = attributes.data.concat([]);
                            newData[index] = {
                              ...newData[index],
                              fa_class: newValue
                            };
                            setAttributes({ data: newData });
                          }}
                        />
                      </BaseControl>
                      <BaseControl>
                        <BaseControl.VisualLabel>Page</BaseControl.VisualLabel>
                        <SelectControl
                          value={menu?.page}
                          options={options}
                          onChange={(newValue) => {
                            const newData = attributes.data.concat([]);
                            newData[index] = {
                              ...newData[index],
                              page: newValue
                            };
                            setAttributes({ data: newData });
                          }}
                        />
                      </BaseControl>
                    </>
                  ) : (
                    <div style={{ marginBottom: "10px" }}>
                      Loading Patterns
                      <Spinner />
                    </div>
                  )}

                  <BaseControl>
                    <a
                      className="custom-btn btn-delete"
                      onClick={() => deleteMenu(index)}
                    >
                      Remove Menu
                    </a>
                  </BaseControl>
                </div>
              );
            })}
            <a
              className="custom-btn btn-add"
              onClick={() => {
                setAttributes({
                  data: attributes.data.concat([undefined])
                });
              }}
            >
              Add New Menu
            </a>
          </FlexBlock>
        </Flex>
      ) : (
        <DesktopMenu data={attributes.data} />
      )}
    </div>
  );
}

function DesktopMenu(props) {
  const { data } = props;

  const menus = data.map((menu, index) => {
    return <li class={` ${index === 0 ? "selected" : ""}`}></li>;
  });

  // return <ul>{menus}</ul>;
  return <>FL Desktop Menu</>;
}
