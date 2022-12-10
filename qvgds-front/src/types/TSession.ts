export type TSession = {
    id: string;
    name?: string;
    status?: 'Done' | 'Draft';
    question?: string[];
  };
  