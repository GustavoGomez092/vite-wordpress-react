import "./App.css";
import { Tabs } from "antd";

const items = [
  {
    key: "1",
    label: "Tab 1",
    children: "Content of Tab Pane 1",
  },
  {
    key: "2",
    label: "Tab 2",
    children: "Content of Tab Pane 2",
  },
  {
    key: "3",
    label: "Tab 3",
    children: "Content of Tab Pane 3",
  },
];

function App() {
  return (
    <>
      <div className="tw-bg-cyan-300 tw-text-black tw-p-6 tw-mt-6 tw-rounded-lg">
        <h2>Application main back-end component:</h2>
        <p>
          Look for the: <code>src/App.jsx</code> file to edit this component.
        </p>
        <Tabs defaultActiveKey="1" items={items} />
      </div>
    </>
  );
}

export default App;
