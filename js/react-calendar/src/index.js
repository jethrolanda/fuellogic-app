import { createRoot } from "@wordpress/element";
import { Calendar, ConfigProvider } from "antd";

const App = () => {
  const onChange = (date) => {
    // delivery_date
    document.getElementById("delivery_date").value = date?.format("MM/DD/YYYY");
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
      <Calendar onChange={onChange} />
    </ConfigProvider>
  );
};
createRoot(document.getElementById("react-calendar")).render(<App />);
