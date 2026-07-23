// Replace your-framework with the framework you are using, e.g. react-vite, nextjs, nextjs-vite, etc.
import type { Meta, StoryObj } from '@storybook/react-vite';

import { DeviceCard } from '../resources/js/components/device-card';

const meta = {
  title: 'Components/DeviceCard',
  component: DeviceCard,
  parameters: {
    layout: 'centered',
  },
  tags: ['mystuff'],
  args: {
    locationName: 'Main Office',
    productName: 'Sensor Model X', 
  },
} satisfies Meta<typeof DeviceCard>;

export default meta;
type Story = StoryObj<typeof meta>;

export const Primary: Story = {
  args: {
    locationName: 'Main Office',
    productName: 'Sensor Model X',
    batteryCharge: 85,
    sensorLife: 90,
    isSubscribed: true,
    order: null,
    onOrderClick: () => {},
    className: '',
    lastUpdate: new Date(),
  },
};