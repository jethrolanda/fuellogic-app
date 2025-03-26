// import { store } from "@wordpress/interactivity";

import { createRoot, useState } from "@wordpress/element";
import { Button, Upload, ConfigProvider } from "antd";
import { PaperClipOutlined } from "@ant-design/icons";

const App = () => {
  // const fla = store("fuellogic-app");
  // const delivery_notes = useSelector(
  //   (state) => state.orderFormState.delivery_notes
  // );

  // const [notes, setNotes] = useState(delivery_notes);

  // https://stackoverflow.com/questions/17992586/allow-only-pdf-doc-docx-format-for-file-upload
  const uploadProps = {
    name: "file",
    accept: "image/png, image/jpeg",
    // "video/mp4, image/png, image/jpeg, application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document",
    action: fuel_logic_app?.ajax_url,
    data: {
      action: "form_add_note_image"
    },
    headers: {
      "X-WP-Nonce": fuel_logic_app.nonce
    },
    onChange(info) {
      console.log(info);
      if (info.file.status !== "uploading") {
        console.log(info.file, info.fileList);
      }
      if (info.file.status === "done") {
        console.log(`${info.file.name} file uploaded successfully`);
        // setNotes((n) => [
        //   ...n,
        //   {
        //     uid: info.file.uid,
        //     name: info.file.name,
        //     type: info.file.type,
        //     url: info.file.response.file.url,
        //     percent: info.file.percent,
        //     status: info.file.status
        //   }
        // ]);
        // <input type="hidden" name="images" class="images">
        var input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "images");
        input.setAttribute("class", "images");
        input.setAttribute("value", info.file.response.file.url);
        document.getElementById("note-images").appendChild(input);

        // Trigger form update
        var event = new Event("change");
        document.getElementById("site-form").dispatchEvent(event);
      } else if (info.file.status === "error") {
        console.log(`${info.file.name} file upload failed.`);
      }
    },
    // defaultFileList: notes,
    onRemove: (file) => {
      // console.log(file);
      const formData = new FormData();

      formData.append("action", "form_remove_note_image");
      formData.append("X-WP-Nonce", fuel_logic_app.nonce);
      formData.append("file", file.response.serialize);

      const data = fetch(fuel_logic_app?.ajax_url, {
        method: "POST",
        body: formData
      }).then((response) => response.json());
    }
    // itemRender: (originNode, file) => <></> // disable antd default render
  };

  return (
    <ConfigProvider
      theme={{
        token: {
          // Seed Token
          colorPrimary: "#a2cd3a",
          colorTextBase: "#D9D9D9",
          colorBgContainer: "black",
          // Alias Token
          colorBgContainer: "transparent",
          miniContentHeight: "10px"
        }
      }}
    >
      <Upload {...uploadProps} className="upload-image">
        <Button
          icon={
            <PaperClipOutlined style={{ fontSize: "20px" }} type="primary" />
          }
          size="large"
        >
          Upload Files
        </Button>
        <p>(Allowed files *.jpeg, *.png)</p>
      </Upload>
    </ConfigProvider>
  );
};
createRoot(document.getElementById("file-uploader")).render(<App />);
